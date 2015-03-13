# Simple Search Tweaks plugin for Omeka

This plugin provides a few tweaks to Omeka's simple (keyword) search.

## Requirements

* Omeka 2.0+

## Installation

1. Download the plugin
2. Extract to the plugins directory of your Omeka installation
3. Install the plugin at `/admin/plugins`

## Configuration

1. Configure the plugin at `/admin/plugins/config/name/SimpleSearchTweaks`
  to enable the tweaks you want.

## Tweaks

### Empty query browse

If a user submits the simple search form without entering any keywords, the
standard behaviour returns 0 search results. Enabling this will instead show
all search results, just like browsing.

### Filter by collection

The standard simple search form does not support limiting by collection.
Enabling this will enable filtering by collection. You will need to add a
collection field to your theme's search form template.
