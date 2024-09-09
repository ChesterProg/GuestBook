<?php

namespace App\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;

class StringToFileTransformer implements DataTransformerInterface
{

	public function transform($value)
	{
		if (null === $value || '' === $value) {
			return null;
		}

		// Assuming $value is the filename, convert it to a File object
		return new File((\dirname(__DIR__, 3).'/public/uploads/images/' . $value));
	}

	public function reverseTransform($value)
	{
		if ($value instanceof File) {
			return $value->getFilename(); // Return the filename as a string
		}

		return $value;
	}
}