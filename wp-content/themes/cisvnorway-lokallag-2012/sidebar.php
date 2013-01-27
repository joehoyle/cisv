				<div id="hovedfelt-hoyre">
					<ul id="sidebar">
						<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
						<li class="punkt-kalender"><a href="/kalender/">Sjekk kalenderen for CISV her!</a></li>
						<?php endif; ?>
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