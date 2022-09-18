<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Samils\ApplicationServer
 * - Autoload, application dependencies
 */
namespace Sammy\Packs\Samils\ApplicationServer {
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  use Sammy\Packs\Samils\ApplicationServer;
  use php\module as phpmodule;

  $InPHPModuleContext = ( boolean )(
    isset ($module) &&
    is_object ($module) &&
    $module instanceof phpmodule
  );

  $server = new ApplicationServer;
  /**
   * setPublicDirectory
   */
  $server->setPublicDirectory (
    ApplicationServerHelpers::PublicDir ()
  );

  if ( $InPHPModuleContext ) {
    $module->exports = $server;
  }

  return $server;
}
