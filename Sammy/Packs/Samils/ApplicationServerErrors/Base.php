<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Samils\ApplicationServerErrors
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
namespace Sammy\Packs\Samils\ApplicationServerErrors {
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists('Sammy\Packs\Samils\ApplicationServerErrors\Base')){
  /**
   * @trait Base
   * Base internal trait for the
   * Samils\ApplicationServerErrors module.
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
    /**
     * @method void NoConfigFile
     *
     */
    public static function NoConfigFile ($trace = null) {
      $error = new SamilsErrorHandler ();
      $sources = [];
      $error->title = 'Samils\\Application\\Server::Error - No config file';
      $error->message = (
        'No application-server configuration file found ' .
        'inside the project config directory.'
      );

      $contentGetter = requires ('file-content-getter');

      if (is_object ($contentGetter)) {
        foreach ($trace as $i => $traceDatas) {

          $shouldExtarctFileSource = ( boolean ) (
            is_array ($traceDatas) &&
            isset ($traceDatas ['file']) &&
            is_string ($traceDatas ['file']) &&
            is_file ($traceDatas ['file'])
          );

          if ( $shouldExtarctFileSource ) {
            $file_lines = $contentGetter->getFileLines (
              $traceDatas ['file'], [ $traceDatas ['line'], 5 ]
            );

            $file = $traceDatas ['file'];
            $file_lines ['@high'] = [$traceDatas['line']];

            $sources ['Extracted source from #' . $file] = (
              $file_lines
            );
          }
        }
      }

      $error->handle ([
        'paragraphes' => [
          'Try creating a \'<span class="blue">application-server.yaml</span>\' file in you config directory.',
          'And add to it The template engine and ORM configurations.',
          'Goto the ils guide to know more about how to resolve this bug.',
          'If you are having any proplem to know what to do, contact your ils dev in order helping you with it.'
        ],

        "sources" => $sources
      ]);
    }

    /**
     * @method void NoStartMethodInViewEngineManager
     */
    public static function NoStartMethodInViewEngineManager ($trace = null) {
      exit ('NoStartMethodInViewEngineManager . ' . __FILE__);
    }
  }}
}
