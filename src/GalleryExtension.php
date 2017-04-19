<?php

namespace Bolt\Extension\Animal\Gallery;

use Bolt\Extension\SimpleExtension;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * ANIMAL Gallery extension class.
 *
 * @author ANIMAL Design OG <studio@animal.at>
 */
class GalleryExtension extends SimpleExtension
{
	private $version = 'v0.0.1';

	protected function registerTwigFunctions() {
		return [
			'imagelist'    => ['imagelistFunction', ['is_variadic' => true]],
		];
	}

	public function imagelistFunction(array $args = []) {
		$defaults = [
			  'folder'  => '/',
			  'ext' => 'jpg,JPG,jpeg,JPEG'
		];

		$args = array_merge($defaults, $args);
		$app = $this->getContainer();
		$path = join('/',
			array(
				$app['paths']['filespath'],
				trim($args['folder'], '/')
			)
		);

		// Check if folder exits
		$fs = new Filesystem();
		if (!$fs->exists($path)) {
			return false;
		}

		// Get all matching files
		$finder = new Finder();
		$finder
			->files()
			->ignoreUnreadableDirs()
			->name('*.{'. $args['ext'].'}')
			->sortByName()
			->in($path);
		
		// Fix path and push into array
		$images = [];
		foreach ($finder as $image) {
			array_push(
				$images,
				str_replace($app['paths']['filespath'], '', $image->getRealPath())
			);
		}

		return $images;
	}
}
