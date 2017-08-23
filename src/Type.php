<?php

declare(strict_types=1);

namespace FondBot\Drivers\Telegram;

use stdClass;
use JsonMapper;
use Illuminate\Contracts\Support\Arrayable;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

abstract class Type implements Arrayable
{
    /**
     * Create type from given json.
     *
     * @param stdClass|array $value
     *
     * @return Type|static|object
     */
    public static function fromJson($value)
    {
        if (is_array($value)) {
            $value = json_decode(json_encode($value));
        }

        $class = static::class;

        return (new JsonMapper)->map($value, new $class);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): ?array
    {
        $normalizer = new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter);
        $serializer = new Serializer([$normalizer]);

        return $serializer->normalize($this);
    }
}
