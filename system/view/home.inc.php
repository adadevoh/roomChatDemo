<section>
	<form id= "join-chat" method ="post" action= <?php echo $join; ?> >
		<h2>Join Chat?</h2>
		<p>Join ongoing chat?</p>
		<label>Enter room id: 
			<input type= "text" name= "roomID" />
		</label>
		<input type= "submit" value= "Join Chat" />
		<input type= "hidden" name= "nonce" value= <?php echo $nonce; ?> />
	</form>
</section>
<form id= "start-chat" method= "post" action= <?php echo $start_chat; ?> >
	<h2>Start a new Chat?</h2>
	<label>What is your name?
		<input type= "text" name= "owner-name" />
	</label>
	<label>Enter your email address
		<input type= "email" name= "owner-email" />
	</label>
	<label>What will you call this session?
		<input type= "text" name= "sessionName"/>
	</label>
	<input type= "submit" value= "Create Chat Room"/>
	<input type= "hidden" name= "nonce" value= <?php echo $nonce; ?> />
</form>