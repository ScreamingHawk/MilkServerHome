		<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<p>&copy; <?php echo date("Y"); ?> Standen Links | <a href="/file/get.php?file=MichaelStandenCV.pdf">By Michael Standen</a></p>
					</div>
				</div>
			</div>
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

