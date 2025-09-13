<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Member;
use Illuminate\Console\Command;
use App\Notifications\FeeStatusNotification;

class NotifyDueFees extends Command
{

    protected $signature = 'notify:due-fees';
    protected $description = 'Send reminders for due monthly fees';

   public function handle()
{
    $dueDate = Carbon::now()->addMinutes(2)->toDateString(); // For testing

    Member::whereHas('monthlyFees', function($q) use ($dueDate) {
        $q->where('status', 'pending')
          ->whereDate('for_month', '<=', $dueDate);
    })->chunk(500, function($members) use ($dueDate) {
        foreach ($members as $member) {
            $latestFee = $member->monthlyFees()->latest()->first();

            \App\Models\Notification::create([
                'user_id'     => null,
                'member_id'   => $member->id,
                'title'       => 'Monthly Fee Due',
                'message'     => "Your monthly fee is due on $dueDate.",
                'type'        => 'fee',
                'amount'      => $latestFee->amount ?? 200,
                'due_date'    => $dueDate,
                'related_type'=> \App\Models\MonthlyFee::class,
                'related_id'  => $latestFee->id ?? null,
            ]);
        }
    });

    $this->info('Due fee notifications processed successfully.');
}

}
