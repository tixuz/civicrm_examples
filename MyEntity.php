/**
 * Get my entity list parameters with multiple search fields.
 *
 * @param array $request
 * @see _civicrm_api3_generic_getlist_params
 *
 */
function _civicrm_api3_my_entity_getlist_params(&$request)
{
// debug log input request
//    CRM_Core_Error::debug_var('request3', $request);
    $params = [];
    if ($request['input']) {
        if ($request['search_fields']) {
            $search_fields = $request['search_fields'];
// debug log search fields
//            CRM_Core_Error::debug_var('search_fields', $search_fields);
            if (sizeof($search_fields) > 0) {

                foreach ($search_fields as $search_field) {
// debug log each search field
//                CRM_Core_Error::debug_var('search_field', $search_field);
                    $params[$search_field] = ['LIKE' => ($request['add_wildcard'] ? '%' : '') . $request['input'] . '%'];
                }
// instead of array_unique
                if (isset($request['search_field'])) {
                    if (!in_array($request['search_field'], $search_fields)) {
                        $search_fields[] = $request['search_field'];
                    };
                }
// won't work without it
                $request['params']['options']['or'] = [$search_fields];
            }
        }
    }
    $request['params'] += $params;
// call generic getlist
    _civicrm_api3_generic_getlist_params($request);
// debug log output request
//    CRM_Core_Error::debug_var('request4', $request);
}
