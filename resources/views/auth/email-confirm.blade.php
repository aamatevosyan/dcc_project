@extends('layouts.mail')
@section('content')
  <h3 class="sm-text-3xl sm-leading-36 sm-mt-16"
      style="font-family: CeraRoundProBold, Avenir, Helvetica, Arial, sans-serif; font-size: 36px; line-height: 32px; margin-bottom: 0; margin-top: 28px;">
    Confirm your email address</h3>
  <div class="sm-mt-16 sm-mb-12" style="margin-bottom: 20px; margin-top: 24px;">
    <p class="sm-text-sm text-input-active sm-mt-8 sm-leading-24"
       style="font-family: CeraRoundPro, Avenir, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 36px; margin-bottom: 0; margin-top: 12px; color: #30302f;">
      Enter the code below in the sign up window to confirm your <br class="sm-hidden">email address and continue
      registration.</p>
  </div>
  <p class="text-input-active sm-mb-20 sm-leading-28"
     style="font-family: CeraRoundProBold, Avenir, Helvetica, Arial, sans-serif; font-size: 24px; line-height: 32px; margin-top: 0; margin-bottom: 24px; padding-top: 12px; padding-bottom: 12px; padding-left: 20px; padding-right: 20px; color: #30302f;">{{$code}}</p>
  <p class="sm-text-sm text-input-active sm-mt-8"
     style="font-family: CeraRoundPro, Avenir, Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; margin-bottom: 0; margin-top: 12px; color: #30302f;">
    If you did not request this, you can safely ignore this email.</p>
@endsection
