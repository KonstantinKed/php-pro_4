<?php


namespace App\ORM\DataMapper\Traits;

use App\ORM\DataMapper\VO\PrivateProperties;
use App\ORM\DataMapper\VO\Property;
use Doctrine\Common\Collections\Collection;

trait JsonSerializableTrait
{

    public function jsonSerialize(?string $lock = null): array
    {
        $data = [];
        $currentClass = get_class($this);

        $refObject = new \ReflectionObject($this);
        foreach ($refObject->getProperties() as $property) {
            if (!empty($privateProperties = $refObject->getAttributes(PrivateProperties::class))) {
                /**
                 * @var PrivateProperties $privateProperties
                 */
                $privateProperties = $privateProperties[0]->newInstance()->getProperties();
                if (isset($privateProperties[$property->getName()])) {
                    continue;
                }
            }
            if ($lock === $property->getType()->getName()) {
                continue;
            }
            $value = $property->getValue($this);
            if ($property->getType()->getName() === Collection::class) {
                /**
                 * @var Collection $value
                 */
                $value = $value->map(function ($v) use ($currentClass) {
                    if ($v instanceof \JsonSerializable) {
                        $v = $v->jsonSerialize($currentClass);
                    }
                    return $v;
                })->toArray();
            }
            $data[$property->getName()] = $value;
        }


        return $data;
    }
}
