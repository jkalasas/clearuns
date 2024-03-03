<?php
function createPasswordInput($name = "", $id = "", $label = "")
{
	$uuid = "pass-" . uniqid();
?>
	<div class="password-input <?php echo $uuid ?>">
		<input type="password" name="<?php echo $name ?>" id="<?php echo $id ?>" placeholder="Password" />
		<button type="button" class="show-btn material-symbols-outlined" data-toggled="false">visibility_off</button>
	</div>

	<script>
		{
			const container = document.querySelector(".<?php echo $uuid ?>");
			const passwordInput = container.querySelector("input[type='password']");
			const toggleBtn = container.querySelector(".show-btn");
			toggleBtn.addEventListener("click", () => {
				let toggled = toggleBtn.dataset.toggled === "true";
				toggleBtn.innerText = toggled ? "visibility_off" : "visibility";
				passwordInput.setAttribute("type", toggled ? "password" : "text");
				toggleBtn.dataset.toggled = toggled ? "false" : "true";
			});
		}
	</script>
<?php } ?>
