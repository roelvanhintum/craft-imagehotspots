<?php

namespace roelvanhintum\imagehotspots\migrations;

use Craft;
use craft\db\Migration;
use craft\services\ProjectConfig;
use roelvanhintum\imagehotspots\fields\ImageHotspots;

/**
 * Points fields created before 3.1.0 at the field type's new namespace.
 */
class m261120_000000_update_field_type_namespace extends Migration
{
    private const OLD_TYPE = 'born05\imagehotspots\fields\ImageHotspots';

    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $projectConfig = Craft::$app->getProjectConfig();

        // Don't make the same config changes twice
        $schemaVersion = $projectConfig->get('plugins.imagehotspots.schemaVersion', true);
        if (version_compare($schemaVersion, '1.1.0', '>=')) {
            return true;
        }

        $fields = $projectConfig->get(ProjectConfig::PATH_FIELDS) ?? [];

        foreach ($fields as $uid => $field) {
            if (($field['type'] ?? null) === self::OLD_TYPE) {
                $projectConfig->set(ProjectConfig::PATH_FIELDS . ".$uid.type", ImageHotspots::class);
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        echo "m261120_000000_update_field_type_namespace cannot be reverted.\n";
        return false;
    }
}
