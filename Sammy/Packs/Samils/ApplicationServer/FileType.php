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
  use Configure as Conf;
  use php\module as phpmodule;
  use FileSystem\Folder as Dir;
  use Samils\Handler\HandleOutPut;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Samils\ApplicationServer\FileType')) {
  /**
   * @trait FileType
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
  trait FileType {
    protected function fileNameAlternates ($fileAbsPath) {
      $typesByExtension = requires ('types-by-extension');
      $fileExtensionsAlternates = $typesByExtension->getExtensions ();

      # preg_split ('/\s+/',
      #   'php php3 php4 php5 php7 ' .
      #   'phps phtml html css js json xml ' .
      #   'jpg png ico'
      # )

      $fileExtensionsAlternatesCount = count ($fileExtensionsAlternates);

      if (file_exists ($fileAbsPath) && is_file ($fileAbsPath)) {
        return $fileAbsPath;
      }

      for ($i = 0; $i < $fileExtensionsAlternatesCount; $i++) {
        $fileExtensionsAlternate = $fileExtensionsAlternates [$i];

        $fileAbsPathAlternate = join (DIRECTORY_SEPARATOR, [
          $fileAbsPath, 'index.' . $fileExtensionsAlternate
        ]);

        if (is_file ($fileAbsPathAlternate)) {
          return $fileAbsPathAlternate;
        }
      }
    }

    /**
     * @method byFileType
     * - Run a file based on the
     * - type (extension) of the
     * - same
     */
    protected function byFileType ($abs = null) {
      $abs = $this->fileNameAlternates ($abs);

      if ( !$abs ) return;

      $fileExtension = pathinfo ($abs, PATHINFO_EXTENSION);

      if (in_array ($fileExtension, ['php']) && is_file ($abs)) {
        header ('Content-Type: text/html');
        exit (include $abs);
      }

      $typesByExtension = requires ('types-by-extension');

      $mimetype = $typesByExtension->getFileMimetype ($abs);

      if (is_null ($mimetype)) {
        $mimetype = 'text/plain';
      }

      header ('Content-Type: ' . $mimetype);
      exit (file_get_contents ($abs));
    }
  }}
}
