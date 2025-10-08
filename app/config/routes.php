<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------
 * LavaLust - an opensource lightweight PHP MVC Framework
 * ------------------------------------------------------------------
 *
 * MIT License
 *
 * Copyright (c) 2020 Ronald M. Marasigan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package LavaLust
 * @author Ronald M. Marasigan <ronald.marasigan@yahoo.com>
 * @since Version 1
 * @link https://github.com/ronmarasigan/LavaLust
 * @license https://opensource.org/licenses/MIT MIT License
 */

/**
| -------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------
| Here is where you can register web routes for your application.
|
*/

// Home route - redirects to students list
$router->get('/', 'StudentsController::index');

// Students routes - CORRECTED to match your existing views
$router->get('/students', 'StudentsController::index');                    // Main students list           
$router->get('/students/index/{page}', 'StudentsController::index');       // Paginated list

// Create student routes
$router->get('/students/create', 'StudentsController::create');   // Show form
$router->post('/students/create', 'StudentsController::create');  // Handle form (no store())
         // Handle create form

// Edit student routes  
$router->get('/students/edit/{id}', 'StudentsController::edit');
$router->post('/students/edit/{id}', 'StudentsController::edit');
    // Handle edit form

// Delete student route
$router->get('/students/delete/{id}', 'StudentsController::delete'); 

// Authentication routes
$router->match('/auth/login', 'AuthController::login', ['GET','POST']);
$router->get('/auth/logout', 'AuthController::logout');
$router->match('/auth/register', 'AuthController::register', ['GET','POST']);
$router->get('/auth/dashboard', 'AuthController::dashboard');