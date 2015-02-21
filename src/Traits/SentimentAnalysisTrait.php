<?php namespace Hopkins\LaravelAylienWrapper\Providers;

trait SentimentAnalysisTrait {
    public static function boot()
    {
        parent::boot();
        Message::created(function(Message $message)
        {
            $user = User::whereUserName($message->user_name)->first();
            $user_id = (count($user)) ? $user->id : null;
            if (0 === strpos($message->message, 'sterling ')) {
                $sentiment = ['polarity' => null,'polarity_confidence' => null,'subjectivity' => null,'subjectivity_confidence' => null];
                $directive = 1;
            }
            else{
                $aylienResponse = Aylien::Sentiment(['text'=>$message->message]);
                $sentiment = [
                    'polarity' => $aylienResponse->polarity,
                    'polarity_confidence' => $aylienResponse->polarity_confidence,
                    'subjectivity' => $aylienResponse->subjectivity,
                    'subjectivity_confidence' => $aylienResponse->subjectivity_confidence
                ];
                $directive = 0;
            }
            $message->update([
                'user_id' => $user_id,
                'polarity' => $sentiment['polarity'],
                'polarity_confidence' => $sentiment['polarity_confidence'],
                'subjectivity' => $sentiment['subjectivity'],
                'subjectivity_confidence' => $sentiment['subjectivity_confidence'],
                'directive' => $directive
            ]);
        });
    }
}