const Sequelize = require('sequelize');

// docker inspect mysql-container para obter o ip => host ou...
const connection = new Sequelize('database_db', 'root', 'senha_db', {
  host:'mysql-container',
  dialect: 'mysql',
  timezone: '-03:00'
})

module.exports = connection;
