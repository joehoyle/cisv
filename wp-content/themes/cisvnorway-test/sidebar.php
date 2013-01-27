				<div id="hovedfelt-hoyre">
					<div id="sidebar-kalender">
						<h2 class="sidebar-heading-link"><a href="/kalender/">Kalender</a></h2>
						<?php if(dynamic_sidebar('sidekolonne1') ) : else : ?>
 						<?php endif; ?>
 						<h3>Lokale aktiviteter</h3>
						<?php echo eventpress_sidebar();?>
 					</div>
					<div class="bli-medlem">
						<a href="/cisv-norge/bli-medlem/" alt="Meld deg inn i CISV Norge" title="Meld deg inn i CISV Norge"><img src="<?php bloginfo('template_url'); ?>/images/bli-medlem.png" /></a>		
					</div>
 					<ul id="sidebar2">
						<?php if(dynamic_sidebar('sidekolonne2') ) : else : ?>
						<li class="punkt-twitter"><a href="http://twitter.com/CISVNorge/">F&oslash;lg CISV Norge p&aring; Twitter her!</a></li>
 						<?php endif; ?>
					</ul>
 					
 					<ul id="sidebar3">
						<?php if(dynamic_sidebar('sidekolonne3') ) : else : ?>
 						<?php endif; ?>
 					</ul>

				</div>