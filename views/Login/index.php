<form action="<?=actionLink('login','Login')?>" method="post">
								<?=Framework\Request::CSRF()?>	
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="email" placeholder="Username..." class="form-username form-control" id="form-username" value="<?=$email?>">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password" value="<?=$password?>">
			                        </div>
			                        <button type="submit" class="btn">Sign in!</button>
			                    </form>
								<?if(isset($message)){?>
								<div class="alert alert-danger">
									<?=$message?>
								</div>
								<?}?>