<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20150212215932 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
		// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE famelo_coff_domain_model_part DROP FOREIGN KEY FK_F706EBC2140AB620");
		$this->addSql("ALTER TABLE famelo_coff_domain_model_part ADD CONSTRAINT FK_F706EBC2140AB620 FOREIGN KEY (page) REFERENCES famelo_coff_domain_model_page (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
		// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE famelo_coff_domain_model_part DROP FOREIGN KEY FK_F706EBC2140AB620");
		$this->addSql("ALTER TABLE famelo_coff_domain_model_part ADD CONSTRAINT FK_F706EBC2140AB620 FOREIGN KEY (page) REFERENCES famelo_coff_domain_model_part (persistence_object_identifier)");
	}
}