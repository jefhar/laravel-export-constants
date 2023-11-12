<?php

namespace LaravelExportConstants;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use LaravelExportConstants\Attributes\ExportToJs;
use LaravelExportConstants\Exceptions\ExportConstantsJsonException;

class LaravelExportConstants
{
    private const CACHE_KEY = 'laravelExportConstants';

    public function __construct(private AttributeClassRegistrar $classRegistrar)
    {
    }

    /**
     * @throws ExportConstantsJsonException
     * @throws \JsonException
     */
    public function generate(): string
    {
        $cachedConstants = $this->getConstants();
        $constants = json_encode(Cache::get(self::CACHE_KEY), JSON_THROW_ON_ERROR | JSON_FORCE_OBJECT);
        if ($constants === false) {
            throw new ExportConstantsJsonException();
        }

        $constants = addslashes($constants);

        return <<<JS
            <script type="text/javascript">
                const handler={get(e,r){if("isProxy"===r)return!0;const o=e[r];return void 0!==o?(o.isProxy||"object"!=typeof o||(e[r]=new Proxy(o,handler)),e[r]):void 0},set:(e,r,o)=>!1},
                CONSTANTS=new Proxy(JSON.parse("$constants"),handler);
                export default CONSTANTS;
            </script>
            JS;
    }

    public function clearCache(): void
    {
        Cache::forget('laravelExportConstants');
    }

    private function getConstants()
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return $this->buildConstants();
        });
    }

    /**
     * @throws Exception
     */
    private function buildConstants(): array
    {
        $constants = [];
        $classes = $this->classRegistrar->getAllClasses();

        foreach ($classes as $class) {
            $constants[] = $this->getConstantsFromClass($class);
        }

        return Arr::collapse($constants);
    }

    private function getConstantsFromClass(string $className): array
    {
        try {
            $reflectionClass = new \ReflectionClass($className);
        } catch (Exception $e) {
            return [];
        }

        $constants = [];

        foreach ($reflectionClass->getConstants(\ReflectionClassConstant::IS_PUBLIC) as $classConstant => $constantValue) {
            $reflectionConstant = new \ReflectionClassConstant($className, $classConstant);
            if ($reflectionConstant->getAttributes(ExportToJs::class)) {
                $constants[class_basename($className)][$classConstant] = $constantValue;
            }
        }

        return $constants;
    }
}
