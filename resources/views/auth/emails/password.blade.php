Click here to reset your password: <a href="{{ $link = request()->header('Origin')."/password/reset/".$token.'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
