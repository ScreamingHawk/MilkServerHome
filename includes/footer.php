		<footer id="footer">
			<div class="container">
				<hr>

				<p>&copy; Standen Links <?php echo date("Y"); ?></p>
			</div> <!-- /container -->
		</footer>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

		<script src="/js/vendor/bootstrap.min.js"></script>

		<script src="/js/main.js"></script>
		
		<?php if ($logged == 'out') : ?>
			<script src="/js/login.js"></script>
			<script src="/js/vendor/sha512.js"></script>
		<?php endif; ?>
		
		<?php if (isset($requires_masonry)) : ?>
			<script src="/js/vendor/masonry.js"></script>
		<?php endif; ?>
	</body>
</html>

