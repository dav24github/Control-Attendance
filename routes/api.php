<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api', 'prefix' => 'auth'],function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'api','namespace'=>'Api'],function ($router) {

    
    
   
    //practicante route 
    Route::get('findPracticanteHistorial','PracticanteController@searchHistorial');
    Route::get('findPracticante','PracticanteController@search');    
    Route::get('get-practicantes','PracticanteController@getPracticantes');
    Route::get('get-historial-practicantes','PracticanteController@indexHistorial');
    Route::apiResource('practicantes','PracticanteController'); //index
    
    Route::get('faltas-info/{id}','FaltaController@faltasPracticante');
    Route::get('permisos-info/{id}','PermisoController@permisosPracticante');
    Route::get('asistencias-info/{id}','AsistenciaController@asistenciasPracticante');
    Route::get('practicante-info/{id}','PracticanteController@showPracticante');
    Route::get('faltas-nro/{id}','FaltaController@nroFaltasPracticante');
    Route::get('asistencias-nro/{id}','AsistenciaController@nroAsistenciasPracticante');
    Route::get('permisos-nro/{id}','PermisoController@nroPermisosPracticante');
    Route::get('dias-trabajo-nro/{id}','AsistenciaController@DiasTrabajados');
    Route::get('total-retraso/{id}','AsistenciaController@totalRetraso');

    //Inactividad route
    Route::post('add-inactividad','InactividadController@inactividadStore');
    Route::patch('inactividad-edit/{id}','InactividadController@inactividadUpdate');
    Route::delete('inactividad-delete/{id}','InactividadController@inactividadDelete');    
    Route::apiResource('inactividades','InactividadController'); //index
    Route::get('get-inactividades','InactividadController@getInactividades');
    Route::post('inactividad-search-month','InactividadController@InactividadMonth');
    Route::get('findInactividad','InactividadController@search');

    //permiso route
    Route::post('add-permiso','PermisoController@permisoStore');
    Route::patch('permiso-edit/{id}','PermisoController@permisoUpdate');
    Route::delete('permiso-delete/{id}','PermisoController@permisoDelete');    
    Route::get('get-permisos','PermisoController@getPermisos');
    Route::get('permiso/{id}','PermisoController@permiso');
    Route::get('findPermiso','PermisoController@search'); 
    Route::post('permiso-search-month','PermisoController@permisoMonth');
    Route::post('permiso-search-date','PermisoController@permisoDate');
    
    //horario route
    Route::get('findHorario','HorarioController@search');    
    Route::get('get-horarios','HorarioController@getHorarios');
    Route::apiResource('horarios','HorarioController'); //index
    Route::get('horario-info/{id}','HorarioController@horarioInfo');
    Route::get('horario-details/{id}','HorarioController@horarioDetails');    
    Route::get('horario-details-more/{id}','HorarioController@horarioDetailsMore');  
    Route::get('horario-details-info/{id}','HorarioController@horarioDetailsInfo');
    Route::get('Horario_details/{id}','HorarioController@detailsHorario');

    //asistencia route
    Route::get('findAsistenciaHistorial','AsistenciaController@searchHistorial');
    Route::get('findAsistencia','AsistenciaController@search');    
    Route::get('get-asistencias','AsistenciaController@getAsistencias');
    Route::get('get-historial-asistencias','AsistenciaController@indexHistorial');
    
    Route::post('add-asistencia-manual','AsistenciaController@asistenciaStoreManual');
    Route::post('add-asistencia','AsistenciaController@asistenciaStore');
        // Route::get('asistencia-info/{id}','OrderController@asistenciaInfo');
    Route::delete('asistencia-delete/{id}','AsistenciaController@asistenciaDelete');
    Route::post('asistencia-search-date','AsistenciaController@asistenciaDate');
    Route::post('asistencia-search-month','AsistenciaController@asistenciaMonth');

    //retraso route
    Route::get('retrasos','AsistenciaController@allRetrasos');
    Route::post('retraso-date','AsistenciaController@retrasoDate');
    Route::post('retraso-month','AsistenciaController@retrasoMonth');

    //falta route
    Route::get('findFaltaHistorial','FaltaController@searchHistorial');
    Route::get('findFalta','FaltaController@search');    
    Route::get('get-faltas','FaltaController@getFaltas');
    Route::get('get-historial-faltas','FaltaController@indexHistorial');
    
    Route::get('update-faltas','FaltaController@faltasStore');
    Route::delete('falta-delete/{id}','FaltaController@faltaDelete');
    Route::post('falta-search-date','FaltaController@faltasDate');
    Route::post('falta-search-month','FaltaController@faltasMonth');
    Route::get('historial-faltas','FaltaController@historialFaltas');

    //home page
    Route::get('today-asistencias','AsistenciaController@todayAsistencias');
    // Route::get('today-sell','OrderController@todaySell');
    // Route::get('today-due','OrderController@todayDue');
    // Route::get('today-expense','OrderController@todayExpense');
});


