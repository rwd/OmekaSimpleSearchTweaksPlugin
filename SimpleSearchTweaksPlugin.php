<?php

/**
 * SimpleSearchTweaks
 * 
 * @copyright Copyright © 2015 Richard Doe
 * @license http://opensource.org/licenses/MIT MIT
 */

/**
 * The SimpleSearchTweaks plugin.
 * 
 * @package Omeka\Plugins\SimpleSearchTweaks
 */
class SimpleSearchTweaksPlugin extends Omeka_Plugin_AbstractPlugin
{
    protected $_hooks = array('install', 'uninstall', 'config_form', 'config', 'search_sql');

    public function hookInstall()
    {
        set_option('simple_search_tweaks_browse_empty_query', 0);
        set_option('simple_search_tweaks_collection_filter', 0);
    }

    public function hookUninstall()
    {
        delete_option('simple_search_tweaks_browse_empty_query');
        delete_option('simple_search_tweaks_collection_filter');
    }
    
    public function hookConfigForm()
    {
        include 'config_form.php';
    }
    
    public function hookConfig($args)
    {
        set_option('simple_search_tweaks_browse_empty_query', $_POST['simple_search_tweaks_browse_empty_query']);
        set_option('simple_search_tweaks_collection_filter', $_POST['simple_search_tweaks_collection_filter']);
    }

    public function hookSearchSql($args) {
        $db = get_db();
        $params = $args['params'];
        $select = $args['select'];

        if (get_option('simple_search_tweaks_browse_empty_query')) {
            // Permit form submissions with no keywords to browse all records
            // @todo Does this interfere with other plugins' search_sql hooks?
            if (empty($params['query'])) {
                $select->reset(Zend_Db_Select::WHERE);
            }
        }
        
        if (get_option('simple_search_tweaks_collection_filter')) {
            // Filter by collection param
            if (isset($params['collection']) && !empty($params['collection'])) {
                $collectionSql = $db->quote($params['collection']);
                $searchRecordTypes = unserialize(get_option('search_record_types'));
                $collectionWhereClauses = array();
                if (in_array('Item', $searchRecordTypes)) {
                    $select->joinLeft(array('i' => 'items'), "search_texts.record_id=i.id AND search_texts.record_type='Item'", array('collection_id'));
                    $collectionWhereClauses[] = "i.collection_id=$collectionSql";
                }
                if (in_array('File', $searchRecordTypes)) {
                    $select->joinLeft(array('f' => 'files'), "search_texts.record_id=f.id AND search_texts.record_type='File'", array());
                    $select->joinLeft(array('fi' => 'items'), "f.item_id=fi.id", array('collection_id'));
                    $collectionWhereClauses[] = "fi.collection_id=$collectionSql";
                }
                if (in_array('File', $searchRecordTypes)) {
                    $select->joinLeft(array('c' => 'collections'), "search_texts.record_id=c.id AND search_texts.record_type='Collection'", array('id'));
                    $collectionWhereClauses[] = "c.id=$collectionSql";
                }
                if (count($collectionWhereClauses) == 0) {
                    // No way to match collection against available search record
                    // types, so force 0 results
                    $select->where('0');
                } else {
                    $select->where('(' . implode(' OR ', $collectionWhereClauses) . ')');
                }
            }
        }
        
#        print_r($select->__toString());exit;
    }
}
