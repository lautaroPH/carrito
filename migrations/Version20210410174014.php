<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410174014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lineas_pedidos ADD order_ref_id INT NOT NULL, CHANGE pedido_id pedido_id INT DEFAULT NULL, CHANGE producto_id producto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lineas_pedidos ADD CONSTRAINT FK_9F6250F9E238517C FOREIGN KEY (order_ref_id) REFERENCES pedidos (id)');
        $this->addSql('CREATE INDEX IDX_9F6250F9E238517C ON lineas_pedidos (order_ref_id)');
        $this->addSql('ALTER TABLE pedidos CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE productos CHANGE categoria_id categoria_id INT DEFAULT NULL, CHANGE fecha fecha DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lineas_pedidos DROP FOREIGN KEY FK_9F6250F9E238517C');
        $this->addSql('DROP INDEX IDX_9F6250F9E238517C ON lineas_pedidos');
        $this->addSql('ALTER TABLE lineas_pedidos DROP order_ref_id, CHANGE pedido_id pedido_id INT NOT NULL, CHANGE producto_id producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos CHANGE usuario_id usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE productos CHANGE categoria_id categoria_id INT NOT NULL, CHANGE fecha fecha DATETIME DEFAULT NULL');
    }
}
