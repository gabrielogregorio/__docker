<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>
<body>
  <?php 
    $result = file_get_contents("http://node-container:9001/");
    $tabela_db = json_decode($result);
  ?>

<section>
  <div class="container">
    <h1>Dados da API NodeJs</h1>
  </div>
</section><!-- Section do titulo  -->

<main>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Produto</th>
          <th>Preco</th>
          <th>Ação</th>
        </tr><!-- tr -->
      </thead><!-- thead -->

      <tbody>
        <?php if ($tabela_db): ?>
          <?php foreach($tabela_db as $product): ?>

            <tr>
              <td><?php echo $product->name; ?></td>
              <td><?php echo $product->price; ?></td>
              <td>
                <form action="http://localhost:9001/product/delete" method="POST">
                  <input type="hidden" name="id" value="<?php echo $product->id; ?>">
                  <input type="submit" value="Remover">
                </form><!-- form -->
              </td>
            </tr>

          <?php endforeach; ?>
        <?php endif; ?>

        <tr>

          <form action="http://localhost:9001/product/create" method="post">
            <td><input type="text" name="name"></td>
            <td><input type="number" name="price"></td>
            <td><input type="submit" value="Adicionar"></td>     
          </form>

        </tr>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>