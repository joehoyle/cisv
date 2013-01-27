				<div id="hovedfelt-hoyre">
					<div class="bli-medlem">
						<a href="/cisv-norge/bli-medlem/" alt="Meld deg inn i CISV Norge" title="Meld deg inn i CISV Norge"><img src="<?php bloginfo('template_url'); ?>/images/bli-medlem.png" /></a>		
					</div>
					<div id="sidebar-kalender">
						<h2 class="sidebar-heading-link"><a href="/kalender/">Kalender</a></h2>
						<?php if(dynamic_sidebar('sidekolonne1') ) : else : ?>
 						<?php endif; ?>
 					<!--	<h3>Lokale aktiviteter</h3>-->
					<!--	<?php // echo eventpress_sidebar();?>-->
 					</div>
 					<ul id="sidebar2">
						<?php if(dynamic_sidebar('sidekolonne2') ) : else : ?>
 						<?php endif; ?>
					</ul>
 					
 					<ul id="sidebar3">
						<?php if(dynamic_sidebar('sidekolonne3') ) : else : ?>
 						<?php endif; ?>
 					</ul>
					<div>
						<ul>
							<li><a href="http://www.facebook.com/cisvnorge" class="ikon-facebook">CISV p&aring; Facebook</a></li>
							<li class="punkt-twitter"><a href="http://twitter.com/CISVNorge/">F&oslash;lg CISV Norge p&aring; Twitter her!</a></li>
							<li><a href="<?php bloginfo('rss2_url'); ?>" class="ikon-rss">Nyheter via RSS</a></li>
						</ul>
					</div>

				</div>