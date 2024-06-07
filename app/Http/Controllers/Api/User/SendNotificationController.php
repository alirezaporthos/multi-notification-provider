<?php

namespace App\Http\Controllers\Api\User;

use App\DataTransferObjects\SendNotificationToUserDTO;
use App\Http\Actions\SendNotificationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\SendNotificationRequest;
use Illuminate\Http\Request;

class SendNotificationController extends Controller
{
    public function __invoke(SendNotificationRequest $request, SendNotificationAction $action)
    {
        $sendNotificationToUserDTO = new SendNotificationToUserDTO(
            userId: $request->user_id,
            preferredNotificationType: $request->preferred_notification_type,
            messageContent: $request->message_content,
        );
        $action->execute($sendNotificationToUserDTO);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification sent successfully.',
        ], 200);
    }
}
