<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
    @include('layouts.head')
    <body>
    <div id="app">
        <escape-component></escape-component>
    </div>
    @include('layouts.footer')
    </body>
    
    </html>