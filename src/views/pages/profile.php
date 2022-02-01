<?php $render('header', ['loggedUser' => $loggedUser]); ?>

<section class="container main">

	<?php $render('aside', ['menuActive' => 'profile']); ?>

	<section class="feed">

		<div class="row">
			<div class="box flex-1 border-top-flat">
				<div class="box-body">
					<div class="profile-cover" style="background-image: url('media/covers/cover.jpg');"></div>
					<div class="profile-info m-20 row">
						<div class="profile-info-avatar">
							<img src="<?=$base;?>/media/avatars/<?=$loggedUser->avatar;?>" />
						</div>
						<div class="profile-info-name">
							<div class="profile-info-name-text"><?=$loggedUser->name;?></div>
							<div class="profile-info-location">Campina Grande</div>
						</div>
						<div class="profile-info-data row">
							<div class="profile-info-item m-width-20">
								<div class="profile-info-item-n">129</div>
								<div class="profile-info-item-s">Seguidores</div>
							</div>
							<div class="profile-info-item m-width-20">
								<div class="profile-info-item-n">363</div>
								<div class="profile-info-item-s">Seguindo</div>
							</div>
							<div class="profile-info-item m-width-20">
								<div class="profile-info-item-n">12</div>
								<div class="profile-info-item-s">Fotos</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

			<div class="column side pr-5">

				<div class="box">
					<div class="box-body">

						<div class="user-info-mini">
							<img src="assets/images/calendar.png" />
							01/01/1930 (90 anos)
						</div>

						<div class="user-info-mini">
							<img src="assets/images/pin.png" />
							Campina Grande, Brasil
						</div>

						<div class="user-info-mini">
							<img src="assets/images/work.png" />
							B7Web
						</div>

					</div>
				</div>

				<div class="box">
					<div class="box-header m-10">
						<div class="box-header-text">
							Seguindo
							<span>(363)</span>
						</div>
						<div class="box-header-buttons">
							<a href="">ver todos</a>
						</div>
					</div>
					<div class="box-body friend-list">

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

						<div class="friend-icon">
							<a href="">
								<div class="friend-icon-avatar">
									<img src="media/avatars/avatar.jpg" />
								</div>
								<div class="friend-icon-name">
									Bonieky
								</div>
							</a>
						</div>

					</div>
				</div>

			</div>
			<div class="column pl-5">

				<div class="box">
					<div class="box-header m-10">
						<div class="box-header-text">
							Fotos
							<span>(12)</span>
						</div>
						<div class="box-header-buttons">
							<a href="">ver todos</a>
						</div>
					</div>
					<div class="box-body row m-20">

						<div class="user-photo-item">
							<a href="#modal-1" rel="modal:open">
								<img src="media/uploads/1.jpg" />
							</a>
							<div id="modal-1" style="display:none">
								<img src="media/uploads/1.jpg" />
							</div>
						</div>

						<div class="user-photo-item">
							<a href="#modal-2" rel="modal:open">
								<img src="media/uploads/1.jpg" />
							</a>
							<div id="modal-2" style="display:none">
								<img src="media/uploads/1.jpg" />
							</div>
						</div>

						<div class="user-photo-item">
							<a href="#modal-3" rel="modal:open">
								<img src="media/uploads/1.jpg" />
							</a>
							<div id="modal-3" style="display:none">
								<img src="media/uploads/1.jpg" />
							</div>
						</div>

						<div class="user-photo-item">
							<a href="#modal-4" rel="modal:open">
								<img src="media/uploads/1.jpg" />
							</a>
							<div id="modal-4" style="display:none">
								<img src="media/uploads/1.jpg" />
							</div>
						</div>

					</div>
				</div>

				<?php foreach($feed['posts'] as $feedItem):?>
                    
                    <?=$render('feed-item', [
                        'post' => $feedItem,
                        'loggedUser' => $loggedUser
                    ]) ?>
                
                <?php endforeach; ?>

                <div class="feed-pagination">
                    <?php for($i = 0; $i < $feed['pageCount'];$i++): ?>
                        
                        <a class="<?=($i==$feed['currentPage']?'active':'')?>" href="<?=$base;?>/perfil?page=<?=$i;?>">
                            <?=$i + 1;?>
                        </a>
                        
                    <?php endfor; ?>
                </div>

			</div>

		</div>

	</section>

</section>
<?php $render('footer'); ?>