@extends('layouts.auth.guest')
@section('content')
<div class="login-form">
    <form action="{{ route('administrator') }}" method="POST">
      @csrf
      <div class="text-center">
        <a href="index.html" aria-label="Space">
          <img class="mb-3" src="{{ asset('storage/images/loga/sr-logo-czarne.svg') }}" alt="Logo" width="420px" height="60" style="max-width: 100%;">
        </a>
      </div>
      <div class="text-center mb-4">
        <h1 class="h3 mb-0">Zaloguj się</h1>
        <p>Zaloguj się aby przejść do Panelu.</p>
      </div>
      <div class="js-form-message mb-3">
        <div class="js-focus-state input-group form">
          <div class="input-group-prepend form__prepend">
            <span class="input-group-text form__text">
              <i class="fa fa-user form__text-inner"></i>
            </span>
          </div>
          <input type="text" class="form-control form__input" name="login" placeholder="E-mail/Login" aria-label="Login" data-msg="Please enter a valid email address." value="{{old('email') ?? ''}}">
        </div>
        @if (isset($errors->messages()['login']))
            <span class="invalid-feedback" style="display: flex;" role="alert">
                <strong>{{ $errors->messages()['login'][0] }}</strong>
            </span>
        @endif
      </div>
      <div class="form-group">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">
              <i class="fa fa-lock"></i>
            </span>
          </div>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        @if (isset($errors->messages()['password']))
            <span class="invalid-feedback" style="display: flex;" role="alert">
                <strong>{{ $errors->messages()['password'][0] }}</strong>
            </span>
        @endif
      </div>
      <div class="row mb-3">
        <div class="col-6">
          <!-- Checkbox -->
          <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
            <input type="checkbox" class="custom-control-input" id="rememberMeCheckbox" name="remember_me" value="1">
            <label class="custom-control-label" for="rememberMeCheckbox">
              Zapamiętaj mnie
            </label>
          </div>
          <!-- End Checkbox -->
        </div>
        <div class="col-6 text-right">
          <a class="float-right" href="recover-account.html">Zapomniałeś/aś hasła?</a>
        </div>
      </div>
      <div class="form-group mb-3">
        <button type="submit" class="btn btn-primary login-btn btn-block">Zaloguj</button>
      </div>
      <p class="small text-center text-muted mb-0">Wszelkie prawa zastrzeżone. © Światrolnika. 2022 Światrolnika.info.</p>
    </form>
  </div>

@endsection
