<?php

declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestTransformer
{
    /**
     * getRequiredField
     * Description : recovery data's parameter from HTTPRequest
     *
     * @param Request $request
     * @param string $fieldName
     * @param bool $isArray
     * @return mixed
     */
    public static function getRequiredField(Request $request, string $fieldName, bool $isArray = false)
    {
        $requestData = \json_decode($request->getContent(), true);

        if ($isArray) {
            $arrayData = self::arrayFlatten($requestData);
            foreach ($arrayData as $key => $value) {
                if ($fieldName === $key) {
                    return $value;
                }
            }

            throw new BadRequestHttpException(\sprintf('Missing POST field %s', $fieldName));
        }

        if (\array_key_exists($fieldName, $requestData)) {
            return $requestData[$fieldName];
        }

        throw new BadRequestHttpException(\sprintf('Missing POST field %s', $fieldName));
    }

    /**
     * arrayFlatten
     * Description : put on the same level the array's keys
     *
     * @param array $array
     * @return array
     */
    private static function arrayFlatten(array $array): array
    {
        $return = [];

        foreach ($array as $key => $value) {
            if (\is_array($value)) {
                $return = \array_merge($return, self::arrayFlatten($value));
            } else {
                $return[$key] = $value;
            }
        }

        return $return;
    }
}