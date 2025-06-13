<?php

    if ( ! function_exists('app_log'))
    {
        /**
         * Decode string encoded with encode()
         *
         * @param $string
         * @return string
         */
        function app_log($user_id, $entity_id, $entity_model, $message, $special_class = null)
        {
            $data = [
                'user_id' => $user_id,
                'entity_id' => $entity_id,
                'entity_model' => $entity_model,
                'message' => $message
            ];

            if (!is_null($special_class))
                $data['special_class'] = $special_class;

            \App\Models\Log::create($data);
        }
    }
