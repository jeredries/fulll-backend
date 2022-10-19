<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018142403 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create Vehicle, Fleet, Location and Messenger tables';
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE fleet_fleet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE vehicle_vehicle_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE fleet (fleet_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(fleet_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A05E1E47A76ED395 ON fleet (user_id)');

        $this->addSql('CREATE TABLE location (location_id INT NOT NULL, vehicle_id INT NOT NULL, fleet_id INT NOT NULL, lat VARCHAR(20) DEFAULT NULL, lng VARCHAR(20) DEFAULT NULL, PRIMARY KEY(location_id))');
        $this->addSql('CREATE INDEX IDX_5E9E89CB545317D1 ON location (vehicle_id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB4B061DF9 ON location (fleet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB545317D14B061DF9 ON location (vehicle_id, fleet_id)');

        $this->addSql('CREATE TABLE vehicle (vehicle_id INT NOT NULL, vehicle_plate_number VARCHAR(50) NOT NULL, PRIMARY KEY(vehicle_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1B80E4864517D8F1 ON vehicle (vehicle_plate_number)');

        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');

        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (vehicle_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB4B061DF9 FOREIGN KEY (fleet_id) REFERENCES fleet (fleet_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE fleet_fleet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_location_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE vehicle_vehicle_id_seq CASCADE');

        $this->addSql('ALTER TABLE location DROP CONSTRAINT FK_5E9E89CB545317D1');
        $this->addSql('ALTER TABLE location DROP CONSTRAINT FK_5E9E89CB4B061DF9');

        $this->addSql('DROP TABLE fleet');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
