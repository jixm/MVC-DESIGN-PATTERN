<?php 
namespace  xhprof;
use System\Common\Functions as Y;


class Debug {
  public static function enable() {
    // xhprof_enable( XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY , $ignored );
    xhprof_enable(  XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
  }
  public static function disable() {
    $data = xhprof_disable();
    $logpath = self::logpath();
    if ( !is_dir( $logpath ) ) {
      mkdir( $logpath, 0755, true );
    }
    include LIB."xhprof/xhprof_lib/utils/xhprof_lib.php";
    include LIB."xhprof/xhprof_lib/utils/xhprof_runs.php";
    $xhprof_runs = new \XHProfRuns_Default($logpath);
    $run_id = $xhprof_runs->save_run($data, SITE);
    self::graph($run_id);
    exit();
  }

  public static function graph( $run ) {

    require_once LIB."xhprof/xhprof_lib/display/xhprof.php";
    require_once LIB."xhprof/xhprof_lib/utils/xhprof_runs.php";

    ini_set( 'max_execution_time', 100 );
    ini_set( 'display_errors' , "Off" );
    error_reporting( 0 );
    $source = SITE;
    $params = array( // run id param
      'run' => array( XHPROF_STRING_PARAM, $run ),

      // source/namespace/type of run
      'source' => array( XHPROF_STRING_PARAM, $source ),

      // the focus function, if it is set, only directly
      // parents/children functions of it will be shown.
      'func' => array( XHPROF_STRING_PARAM, '' ),

      // image type, can be 'jpg', 'gif', 'ps', 'png'
      'type' => array( XHPROF_STRING_PARAM, 'png' ),

      // only functions whose exclusive time over the total time
      // is larger than this threshold will be shown.
      // default is 0.01.
      'threshold' => array( XHPROF_FLOAT_PARAM, 0.01 ),

      // whether to show critical_path
      'critical' => array( XHPROF_BOOL_PARAM, true ),

      // first run in diff mode.
      'run1' => array( XHPROF_STRING_PARAM, '' ),

      // second run in diff mode.
      'run2' => array( XHPROF_STRING_PARAM, '' )
    );

    // pull values of these params, and create named globals for each param
    xhprof_param_init( $params );

    // if invalid value specified for threshold, then use the default
    $threshold = 0.01;

    $type = 'png'; 

    $xhprof_runs_impl = new \XHProfRuns_Default( self::logpath() );
      // single run call graph image generation
    xhprof_render_image( $xhprof_runs_impl, $run, $type,$threshold, $func, $source, $critical );



  }

  public static function logpath() {
    return ROOT."data/xhprof/".SITE;
  }
}