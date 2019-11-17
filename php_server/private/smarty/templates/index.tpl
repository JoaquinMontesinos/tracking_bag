<!DOCTYPE html>
<html lang="en">
	<head>
		{include file="general_head.tpl"}

    {*JS y CSS personalizados
		<script async src="assets/js/*****.js"></script>*}
	</head>

  <body>
    {include file="header.tpl"}
    <main class="container">
      <h1>Flights</h1>
      <ul class="list-group">
        <a href="/trackbag" title="">
          <li class="list-group-item">Flight to {$customer['target']}</li>
        </a>
      </ul>
      <br>
      <br>
    </main>
    {include file="footer.tpl"}
  </body>

	{include file="general_foot.tpl"}
</html>