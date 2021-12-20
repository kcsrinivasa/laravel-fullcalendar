
# Laravel Fullcalendar with CRUD Event with drag and drop

Hi All!

Here is the example focused on laravel fullcalendar. This example will help you laravel fullcalendar tutorial. Here you will learn how to use fullcalendar in laravel. you'll learn laravel implement fullcalendar

### Preview
![Create Event](https://github.com/kcsrinivasa/laravel-fullcalendar/blob/main/output/events.jpg?raw=true)

![Create Event](https://github.com/kcsrinivasa/laravel-fullcalendar/blob/main/output/update_delete_event.jpg?raw=true)


![Create Event](https://raw.githubusercontent.com/kcsrinivasa/laravel-fullcalendar/main/output/add%20event.jpg)

![Create Event](https://github.com/kcsrinivasa/laravel-fullcalendar/blob/main/output/drag_drop_event.jpg?raw=true)



we will simply create crud application with fullcalender so you can easily create event, edit event by drag and drop, delete event with priority of event. in this example we will create events table with start, edit date and title column. then you can add, edit and delete that event with database.


### Step 1: Install Laravel
```bash
composer create-project --prefer-dist laravel/laravel fullcalendar
```

### Step 2: Create Model,Migration,Controller
```bash
php artisan make:model FullCalendar -mcr
```
After this command you will find one file in following path "database/migrations" and you have to put bellow code in your migration file for create events table

```javascript
Schema::create('full_calendars', function (Blueprint $table) {
  $table->id();
  $table->string('title');
  $table->dateTime('start');
  $table->dateTime('end');
  $table->string('colorCode')->nullable();
  $table->timestamps();
});
```
Add fillable fields in app\Models\FullCalendar.php
```javascript
protected $fillable = [ 'title', 'start', 'end','colorCode' ];
```
Then after, update database credentials in .env file and simply run migration
```bash
php artisan migrate
```
### Step 3: Add Routes
```bash
Route::resource('fullcalender','App\Http\Controllers\FullCalendarController');
```
### Step 4: Add functions in Controller
Add below functions in app/Http/Controllers/FullCalendarController.php
```bash
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if($request->ajax()) {
             $data = FullCalendar::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get();
             return response()->json($data);
        }
        return view('fullcalender.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [ 
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'colorCode' => $request->colorCode
                ];
        $event = FullCalendar::create($data);   
        return response()->json($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fullCalendar_id)
    {
        $fullCalendar = FullCalendar::find($fullCalendar_id);
        $data = $request->validate([
                    'title' => 'nullable',
                    'start' => 'nullable|date',
                    'end' => 'nullable|date',
                    'colorCode' => 'nullable',
                ]);
        $fullCalendar->update($data);  
        return response()->json($fullCalendar);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FullCalendar  $fullCalendar
     * @return \Illuminate\Http\Response
     */
    public function destroy($fullCalendar_id)
    {
        $fullCalendar = FullCalendar::find($fullCalendar_id);
        $event = $fullCalendar->delete();
        return response()->json($event);
    }
```

### Step 4: Create Blade file

Goto "resources/views/fullcalender/index.blade.php" and grab the code

### Step 5: Final run and check in browser
```bash
mv server.php index.php
cp public/.htaccess .
```
open in browser
```bash
http://localhost/laravel/fullcalendar
```
