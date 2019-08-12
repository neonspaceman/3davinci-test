<?php

namespace Github\Entity;


abstract class Entity
{
  private $data = null;

  public function __construct(array $data = [])
  {
    $this->data = $data;
  }

  public function __call($method, $arguments)
  {
    $property = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', substr($method, 3)));

    $action = substr($method, 0, 3);
    switch ($action) {
      case 'get':
        return $this->data[$property] ?? null;

      case 'set':
        $this->$property = $arguments[0];
        return $this;
    }
    return null;
  }
}