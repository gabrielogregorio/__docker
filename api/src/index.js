const express = require('express');
const connection = require('./database/database');

const Product = require('./products/Product');
const ProductsController = require('./products/ProductsController');

const app = express();


connection.authenticate().then(() => {
  console.log('Connected!')
}).catch((error) => {
  console.log(error);
})

app.use(express.urlencoded({extended: false}));
app.use(express.json())
app.use('/', ProductsController);

app.get('/', (req, res) => {
  Product.findAll({
    order: [['id', 'DESC']]
  }).then(products => {
    res.send(products)
  })
});


app.listen(9001, '0.0.0.0', () => {
  console.log('Listening on port 9001');
})
