<?php

namespace Clearuns\Component\Input;

class PasswordInput
{
	/** @var bool */
	static private $scriptRendered = false;

	static public function render($name = "password", $id = "", $placeholder = "Password")
	{ ?>
		<div class="password-input">
			<input type="password" name="<?php echo $name ?>" id="<?php echo $id ?>" placeholder="<?php echo $placeholder ?>" />
			<button type="button" class="show-btn material-symbols-outlined" data-toggled="false">visibility_off</button>
		</div>
	<?php
	}

	static public function renderScript(bool $force = false)
	{
		if (static::$scriptRendered && !$force) return;
	?>
		<script>
			{
				const containers = document.querySelectorAll(".password-input");
				containers.forEach((container) => {
					const passwordInput = container.querySelector("input[type='password']");
					const toggleBtn = container.querySelector(".show-btn");
					toggleBtn.addEventListener("click", () => {
						let toggled = toggleBtn.dataset.toggled === "true";
						toggleBtn.innerText = toggled ? "visibility_off" : "visibility";
						passwordInput.setAttribute("type", toggled ? "password" : "text");
						toggleBtn.dataset.toggled = toggled ? "false" : "true";
					});
				});
			}
		</script>
<?php
		static::$scriptRendered = true;
	}
}
?>
