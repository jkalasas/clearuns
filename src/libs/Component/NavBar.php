<?php

namespace Clearuns\Component;

class NavBar
{

	/**
	 * @param string[] $links links in the navbar
	 */
	static public function render(array $links)
	{
		$currentPath = parse_url($_SERVER["REQUEST_URI"])["path"];
?>
		<nav class="navbar">
			<ul class="nav-items mobile">
				<?php foreach ($links as $link) { ?>
					<li class="nav-item <?php echo $currentPath == $link["path"] ? "active" : "" ?> ">
						<a href="<?php echo $link["path"] ?>" class="material-symbols-outlined">
							<?php echo $link["icon"] ?>
						</a>
					</li>
				<?php } ?>
			</ul>
			<ul class="nav-items desktop">
				<?php foreach ($links as $link) { ?>
					<li class="nav-item <?php echo $currentPath == $link["path"] ? "active" : "" ?> ">
						<a href="<?php echo $link["path"] ?>" class="font-passion-one"><?php echo $link["label"] ?></a>
					</li>
				<?php } ?>
			</ul>
		</nav>
<?php
	}
}
