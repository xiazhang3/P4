      
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">

        <div class="navbar-header">
           <ul class="nav nav-pills pull-left">
              <li class="active"><a href="/">Home</a></li>
              <li><a href=<?php echo url('rec-lett-org'); ?> >Add Recipient</a></li>
              <li><a href=<?php echo url('recipient'); ?> >Show Recipients</a></li>
          </ul>
        </div>


        <div class="navbar-collapse collapse navbar-right">
            <?php if(Auth::check()): ?>
                <span class='text-warning' id="user_email"> <?php echo 'Hello, '.Auth::user()->username; ?></span>

                <a href='/logout' role="button" class="btn  btn-warning">Log out</a>
            <?php else: ?>
                <a href='/login' role="button" class="btn btn-warning">Login</a>
            <?php endif ?>       

          </div><!--/.navbar-collapse -->
      
      </div><!--container-->
  </div>