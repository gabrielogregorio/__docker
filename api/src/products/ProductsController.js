const express = require('express');
const Product = require('./Product');

const router = express.Router();

router.post('/product/create', (req, res) => {
  var name = req.body.name;
  var price = req.body.price;
  Product.create({
    name: name,
    price: price
  }).then(() => {
    res.redirect('http://localhost:8888');
  })  
})

router.post('/product/delete', (req, res) => {
  var id = req.body.id;

  Product.destroy({
    where: {id:id}
  }).then(() => {
    res.redirect('http://localhost:8888');
  }) 
})

module.exports = router;
