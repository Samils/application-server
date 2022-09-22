<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Samils\ApplicationServer
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\Samils\ApplicationServer {
  use Closure;
  use Configure as Conf;
  use php\module as phpmodule;
  use FileSystem\Folder as Dir;
  use Samils\Handler\HandleOutPut;
  use Sammy\Packs\Sami\RouteDatas;
  use Sammy\Packs\Samils\ApplicationStorage;
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Samils\ApplicationServer\Base')) {
  /**
   * @trait Base
   * Base internal trait for the
   *\Samils\ApplicationServer module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * wich should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  trait Base {
    use FileType;
    use Configure;

    /**
     * @var public
     * - Absolute path to the application
     * - public directory inside the application
     * - project directory
     */
    private $public;

    public function serve (Dir $dir) {
      if (!isset ($_SERVER ['REQUEST_URI'])) {
        return 0;
      }

      ApplicationStorage::on ('ShutDown', $this->getShutDownHandler ());

      /**
       * @var requestFileName
       * - The requested file name
       * - ?inside the public directory
       */
      $requestFileName = $_SERVER ['REQUEST_URI'];

      $staticFilePath = $this->getStaticFilePath ($requestFileName);

      if (is_file ($staticFilePath)) {
        $staticFileExtension = pathinfo ($staticFilePath, 4);
        $this->byFileType ($staticFilePath, $staticFileExtension);
      }
    }

    public function setPublicDirectory ($dir = null) {
      if (is_string ($dir) && is_dir($dir)) {
        $this->public = $dir;
      }
    }

    public function getStaticFilePath ($requestFileName) {
      $startSlashRe = '/^(\.*(\\\|\/)*)+/';
      $requestFileName = preg_replace ($startSlashRe, '', $requestFileName);

      $dir = new Dir (ApplicationServerHelpers::PublicDir ());


      $applicationAssestsPath = preg_replace ('/^(\/|\\\)+/', '', preg_replace ('/(\/|\\\)+$/', '',
        HandleOutPut::path2re (ApplicationServerHelpers::AssetsPath ())
      ));

      $applicationAssestsPathRe = '/^\/?'.$applicationAssestsPath.'\/(.*)$/i';

      $staticFilesPath = 'static';

      if (isset (self::$config ['static'])
        && is_array (self::$config ['static'])
        && isset (self::$config ['static']['path'])
        && is_string (self::$config ['static']['path'])) {
        $staticFilesPath = self::$config ['static']['path'];
      }

      $requestFileNameAlternatePaths = [
        join ('/', [$requestFileName]),
        join ('.', [$requestFileName, 'php']),
        join ('.', [$requestFileName, 'html']),
        join ('/', [$staticFilesPath, $requestFileName]),
        join ('/', [$staticFilesPath, join ('.', [$requestFileName, 'php'])]),
        join ('/', [$staticFilesPath, join ('.', [$requestFileName, 'html'])])
      ];

      foreach ($requestFileNameAlternatePaths as $requestFileNameAlternatePath) {
        if ($dir->contains ($requestFileNameAlternatePath)) {
          return $dir->abs ($requestFileNameAlternatePath);
        } elseif (@preg_match ($applicationAssestsPathRe, $requestFileNameAlternatePath, $match)) {
          $assets = new Dir (ApplicationServerHelpers::AssetsDir ());
          $filePath = isset ($match [1]) ? $match [1] : $match [0];

          if ($assets->contains ($filePath)) {
            return $assets->abs ($filePath);
          }
        }
      }
    }

    protected function getShutDownHandler () {
      $handler = (function () {
        /**
         * @var requestFileName
         * - The requested file name
         * - ?inside the public directory
         */
        $requestFileName = $_SERVER ['REQUEST_URI'];

        if (RouteDatas::RouteExists ($requestFileName)) {
        }
      });

      return Closure::bind ($handler, $this, static::class);
    }
  }}
}
