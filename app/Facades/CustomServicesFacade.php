<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


/*
-----------------------------------------------------------------------
|  Facade - Creating Static Interface to Application's Service Container
-----------------------------------------------------------------------
|  Following is a short step by step Guide on How to Create a Facade in Laravel
|  http://stackoverflow.com/questions/16957790/how-do-i-create-a-facade-class-with-laravel#answers-header
*/

class CustomServicesFacade extends Facade
{
  /*
  -----------------------------------------------------------------------
  |  Get the CustomServicesFacade Response Component
  -----------------------------------------------------------------------
  |  INFO: CustomServicesFacade Facade extends the base Facade class and defines the method getFacadeAccessor().
  |  This method's job is to return the name of a service container binding.
  |
  |  @return Singleton Instance of 'ServicesHandler'
  */
  protected static function getFacadeAccessor()
  {
    return 'CustomServices';
  }
}
