<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryMemberController extends Controller
{
    private $historyData = [
        [
            'id' => '1',
            'type' => 'Commission',
            'title' => 'Headshot',
            'date' => '07 Sept 2025',
            'price' => 'Rp. 50.000',
            'status' => 'Pending',
            'description' => 'Headshot digital art dalam gaya semi-realistic dengan background polos.',
            'image' => 'https://i.pinimg.com/736x/1c/af/75/1caf75cfd4fdf87db4dcdc5a97e809f2.jpg',
        ],
        [
            'id' => '2',
            'type' => 'Commission',
            'title' => 'Full Body',
            'date' => '13 Nov 2025',
            'price' => 'Rp. 50.000',
            'status' => 'On Progress',
            'description' => 'Full body commission dengan background detail sesuai permintaan klien.',
            'image' => '/images/history/fullbody.png',
        ],
        [
            'id' => '3',
            'type' => 'OC Art',
            'title' => 'Coco Cho..',
            'date' => '13 Nov 2025',
            'price' => 'Rp. 100.000',
            'status' => 'Pending',
            'description' => 'Fanart OC “Coco Cho” dengan ekspresi ceria dan warna pastel.',
            'image' => '/images/history/cococho.png',
        ],
        [
            'id' => '4',
            'type' => 'OC Art',
            'title' => 'Rotor Wild',
            'date' => '13 Nov 2025',
            'price' => 'Rp. 100.000',
            'status' => 'Confirmed',
            'description' => 'OC Art bertema futuristik dengan efek cahaya biru neon.',
            'image' => '/images/history/rotorwild.png',
        ],
        [
            'id' => '5',
            'type' => 'Commission',
            'title' => 'Full Body',
            'date' => '13 Nov 2025',
            'price' => 'Rp. 50.000',
            'status' => 'Finished',
            'description' => 'Full body character art dengan gaya chibi, sudah selesai dan dikirim.',
            'image' => '/images/history/fullbody_finished.png',
        ],
    ];

    public function index()
    {
        $historyData = $this->historyData;
        return view('member.history', compact('historyData'));
    }

    public function detail($id)
    {
        $item = collect($this->historyData)->firstWhere('id', $id);

        if (!$item) {
            abort(404, 'History item not found.');
        }

        return view('member.history_detail', compact('item'));
    }
}
