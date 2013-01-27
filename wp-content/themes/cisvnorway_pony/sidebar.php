				<div id="hovedfelt-hoyre">
					<?php switch_to_blog(1); ?>
					<div class="bli-medlem">
						<a href="/cisv-norge/bli-medlem/" alt="Meld deg inn i CISV Norge" title="Meld deg inn i CISV Norge"><img src="<?php bloginfo('template_url'); ?>/images/bli-medlem.png" /></a>		
					</div>
					<?php restore_current_blog(); ?>
					<ul id="sidebar">
						<li class="punkt-kalender"><a href="/kalender/">Hva skjer i CISV? Sjekk kalenderen her!</a></li>
 					</ul>

 					<ul id="sidebar2">
						<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
						<li class="punkt-twitter"><a href="http://twitter.com/CISVNorge/">F&oslash;lg CISV Norge p&aring; Twitter her!</a></li>
 						<?php endif; ?>
					</ul>
 					
 					<ul id="sidebar3">
						<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : ?>
 						<?php endif; ?>
 					</ul>

				</div>