<?php

namespace VariableAnalysis\Lib;

class Constants {
  /**
   *  Array of known pass-by-reference functions and the argument(s) which are passed
   *  by reference, the arguments are numbered starting from 1 and an elipsis '...'
   *  means all argument numbers after the previous should be considered pass-by-reference.
   *
   *  @return array[]
   */
  public static function getPassByReferenceFunctions() {
    return [
      '__soapCall' => [5],
      'addFunction' => [3],
      'addTask' => [3],
      'addTaskBackground' => [3],
      'addTaskHigh' => [3],
      'addTaskHighBackground' => [3],
      'addTaskLow' => [3],
      'addTaskLowBackground' => [3],
      'addTaskStatus' => [2],
      'apc_dec' => [3],
      'apc_fetch' => [2],
      'apc_inc' => [3],
      'areConfusable' => [3],
      'array_multisort' => [1],
      'array_pop' => [1],
      'array_push' => [1],
      'array_replace' => [1],
      'array_replace_recursive' => [1, 2, 3, '...'],
      'array_shift' => [1],
      'array_splice' => [1],
      'array_unshift' => [1],
      'array_walk' => [1],
      'array_walk_recursive' => [1],
      'arsort' => [1],
      'asort' => [1],
      'bindColumn' => [2],
      'bindParam' => [2],
      'bind_param' => [2, 3, '...'],
      'bind_result' => [1, 2, '...'],
      'call_user_method' => [2],
      'call_user_method_array' => [2],
      'curl_multi_exec' => [2],
      'curl_multi_info_read' => [2],
      'current' => [1],
      'dbplus_curr' => [2],
      'dbplus_first' => [2],
      'dbplus_info' => [3],
      'dbplus_last' => [2],
      'dbplus_next' => [2],
      'dbplus_prev' => [2],
      'dbplus_tremove' => [3],
      'dns_get_record' => [3, 4],
      'domxml_open_file' => [3],
      'domxml_open_mem' => [3],
      'each' => [1],
      'enchant_dict_quick_check' => [3],
      'end' => [1],
      'ereg' => [3],
      'eregi' => [3],
      'exec' => [2, 3],
      'exif_thumbnail' => [1, 2, 3],
      'expect_expectl' => [3],
      'extract' => [1],
      'filter' => [3],
      'flock' => [2,3],
      'fscanf' => [2, 3, '...'],
      'fsockopen' => [3, 4],
      'ftp_alloc' => [3],
      'get' => [2, 3],
      'getByKey' => [4],
      'getMulti' => [2],
      'getMultiByKey' => [3],
      'getimagesize' => [2],
      'getmxrr' => [2, 3],
      'gnupg_decryptverify' => [3],
      'gnupg_verify' => [4],
      'grapheme_extract' => [5],
      'headers_sent' => [1, 2],
      'http_build_url' => [4],
      'http_get' => [3],
      'http_head' => [3],
      'http_negotiate_charset' => [2],
      'http_negotiate_content_type' => [2],
      'http_negotiate_language' => [2],
      'http_post_data' => [4],
      'http_post_fields' => [5],
      'http_put_data' => [4],
      'http_put_file' => [4],
      'http_put_stream' => [4],
      'http_request' => [5],
      'isSuspicious' => [2],
      'is_callable' => [3],
      'key' => [1],
      'krsort' => [1],
      'ksort' => [1],
      'ldap_get_option' => [3],
      'ldap_parse_reference' => [3],
      'ldap_parse_result' => [3, 4, 5, 6],
      'localtime' => [2],
      'm_completeauthorizations' => [2],
      'maxdb_stmt_bind_param' => [3, 4, '...'],
      'maxdb_stmt_bind_result' => [2, 3, '...'],
      'mb_convert_variables' => [3, 4, '...'],
      'mb_parse_str' => [2],
      'mqseries_back' => [2, 3],
      'mqseries_begin' => [3, 4],
      'mqseries_close' => [4, 5],
      'mqseries_cmit' => [2, 3],
      'mqseries_conn' => [2, 3, 4],
      'mqseries_connx' => [2, 3, 4, 5],
      'mqseries_disc' => [2, 3],
      'mqseries_get' => [3, 4, 5, 6, 7, 8, 9],
      'mqseries_inq' => [6, 8, 9, 10],
      'mqseries_open' => [2, 4, 5, 6],
      'mqseries_put' => [3, 4, 6, 7],
      'mqseries_put1' => [2, 3, 4, 6, 7],
      'mqseries_set' => [9, 10],
      'msg_receive' => [3, 5, 8],
      'msg_send' => [6],
      'mssql_bind' => [3],
      'natcasesort' => [1],
      'natsort' => [1],
      'ncurses_color_content' => [2, 3, 4],
      'ncurses_getmaxyx' => [2, 3],
      'ncurses_getmouse' => [1],
      'ncurses_getyx' => [2, 3],
      'ncurses_instr' => [1],
      'ncurses_mouse_trafo' => [1, 2],
      'ncurses_mousemask' => [2],
      'ncurses_pair_content' => [2, 3],
      'ncurses_wmouse_trafo' => [2, 3],
      'newt_button_bar' => [1],
      'newt_form_run' => [2],
      'newt_get_screen_size' => [1, 2],
      'newt_grid_get_size' => [2, 3],
      'newt_reflow_text' => [5, 6],
      'newt_win_entries' => [7],
      'newt_win_menu' => [8],
      'next' => [1],
      'oci_bind_array_by_name' => [3],
      'oci_bind_by_name' => [3],
      'oci_define_by_name' => [3],
      'oci_fetch_all' => [2],
      'ocifetchinto' => [2],
      'odbc_fetch_into' => [2],
      'openssl_csr_export' => [2],
      'openssl_csr_new' => [2],
      'openssl_open' => [2],
      'openssl_pkcs12_export' => [2],
      'openssl_pkcs12_read' => [2],
      'openssl_pkey_export' => [2],
      'openssl_private_decrypt' => [2],
      'openssl_private_encrypt' => [2],
      'openssl_public_decrypt' => [2],
      'openssl_public_encrypt' => [2],
      'openssl_random_pseudo_bytes' => [2],
      'openssl_seal' => [2, 3],
      'openssl_sign' => [2],
      'openssl_x509_export' => [2],
      'ovrimos_fetch_into' => [2],
      'parse' => [2,3],
      'parseCurrency' => [2, 3],
      'parse_str' => [2],
      'parsekit_compile_file' => [2],
      'parsekit_compile_string' => [2],
      'passthru' => [2],
      'pcntl_sigprocmask' => [3],
      'pcntl_sigtimedwait' => [2],
      'pcntl_sigwaitinfo' => [2],
      'pcntl_wait' => [1],
      'pcntl_waitpid' => [2],
      'pfsockopen' => [3, 4],
      'php_check_syntax' => [2],
      'poll' => [1, 2, 3],
      'preg_filter' => [5],
      'preg_match' => [3],
      'preg_match_all' => [3],
      'preg_replace' => [5],
      'preg_replace_callback' => [5],
      'prev' => [1],
      'proc_open' => [3],
      'query' => [3],
      'queryExec' => [2],
      'reset' => [1],
      'rsort' => [1],
      'settype' => [1],
      'shuffle' => [1],
      'similar_text' => [3],
      'socket_create_pair' => [4],
      'socket_getpeername' => [2, 3],
      'socket_getsockname' => [2, 3],
      'socket_recv' => [2],
      'socket_recvfrom' => [2, 5, 6],
      'socket_select' => [1, 2, 3],
      'sort' => [1],
      'sortWithSortKeys' => [1],
      'sqlite_exec' => [3],
      'sqlite_factory' => [3],
      'sqlite_open' => [3],
      'sqlite_popen' => [3],
      'sqlite_query' => [4],
      'sqlite_unbuffered_query' => [4],
      'sscanf' => [3, '...'],
      'str_ireplace' => [4],
      'str_replace' => [4],
      'stream_open' => [4],
      'stream_select' => [1, 2, 3],
      'stream_socket_accept' => [3],
      'stream_socket_client' => [2, 3],
      'stream_socket_recvfrom' => [4],
      'stream_socket_server' => [2, 3],
      'system' => [2],
      'uasort' => [1],
      'uksort' => [1],
      'unbufferedQuery' => [3],
      'usort' => [1],
      'wincache_ucache_dec' => [3],
      'wincache_ucache_get' => [2],
      'wincache_ucache_inc' => [3],
      'xdiff_string_merge3' => [4],
      'xdiff_string_patch' => [4],
      'xml_parse_into_struct' => [3, 4],
      'xml_set_object' => [2],
      'xmlrpc_decode_request' => [2],
      'xmlrpc_set_type' => [1],
      'xslt_set_object' => [2],
      'yaml_parse' => [3],
      'yaml_parse_file' => [3],
      'yaml_parse_url' => [3],
      'yaz_ccl_parse' => [3],
      'yaz_hits' => [2],
      'yaz_scan_result' => [2],
      'yaz_wait' => [1],
    ];
  }

  /**
   * @return array[]
   */
  public static function getWordPressPassByReferenceFunctions() {
    return [
      'wp_parse_str' => [2],
      'wp_cache_get' => [4],
    ];
  }

  /**
   * A regexp for matching variable names in double-quoted strings.
   *
   * @return string
   */
  public static function getDoubleQuotedVarRegexp() {
    return '|(?<!\\\\)(?:\\\\{2})*\${?([a-zA-Z0-9_]+)}?|';
  }
}
