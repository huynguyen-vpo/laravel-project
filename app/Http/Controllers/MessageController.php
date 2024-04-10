<?php

namespace App\Http\Controllers;

use App\Mail\GreetingMail;
use App\Models\Message;
use Database\Factories\MessageFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
class MessageController extends Controller
{
    const PAGE_INDEX = 1;
    const PAGE_SIZE = 10;
    const SEARCH = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        //
        $page = self::PAGE_INDEX; 
        $size = self::PAGE_SIZE;
        logger(request('page'));
        if(request('page')) $page = request('page');
        else if(request('size')) $size = request('size');

        if($filter = request('filter')){
            logger($filter[0]);
            if($filter[0] != '+' && $filter[0] != '-'){
                return response()->json([
                    "status" => "Bad Request",
                    "message"=> "Filter required +- field",
                ], Response::HTTP_BAD_REQUEST); 
            }
            if($filter[0] == '+'){
                $filter = ltrim($filter, $filter[0]);
                $messages = Message::where('content','like','%'. request('search') .'%')->orderBy($filter, "asc")->paginate($size, ["*"],"page", $page);
            }
            else{
                $filter = ltrim($filter, $filter[0]);
                logger($size);
                $messages = Message::where('content','like','%'. request('search') .'%')->orderBy($filter, "desc")->paginate($size, ["*"],"page", $page);
            }
        }
        return response()->json([
            "status" => "Ok",
            "message"=> $messages,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:10'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=> 400,
                'errors' => $validator->getMessageBag(),
            ]);
        }
        $message = Message::create([
            'content'=> $request->content,
        ]);

        Mail::to('huynquose.12@gmail.com')->send(new GreetingMail($message->content + " " + "Created"));
        return response()->json([
            'status'=> 200,
            'message'=> $message
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
        return response()->json([
            'data' => Message::find($id)
        ], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:10'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'=> 400,
                'errors' => $validator->getMessageBag(),
            ]);
        }
        $message = Message::find($id);
        $message->content = $request->content;

        $check = $message->save();
        if($check){
            return response()->json([
                'status'=> 200,
                'data' => $message,
            ], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
        Message::destroy($id);
    }
    private function wrapResponse(int $code, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'code' => $code,
            'message' => $message
        ];

        if (count($resource)) {
            $result = array_merge($result, ['data' => $resource['data']]);

            if (count($resource) > 1)
                $result = array_merge($result, ['pages' => ['links' => $resource['links'], 'meta' => $resource['meta']]]);
        }

        return response()->json($result, $code);
    }
}
