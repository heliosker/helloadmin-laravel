<?php
/**
 *
 * User: bing <codingbing@163.com>
 * Date: 2020/12/28 10:47
 */

namespace App\Traits;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Validation\Validator;

trait JsonResponse
{
    protected $data = [];
    protected $statusCode;
    protected $message = 'message';


    /**
     * 设置 HTTP 状态码.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function statusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * 响应信息
     *
     * @param string|null $message
     * @return $this
     */
    public function message(?string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 成功 响应.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success()
    {
        return $this
            ->statusCode(200)
            ->send();
    }

    /**
     * 失败 响应.
     *
     * @param string $message
     * @param int|null $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(string $message, ?int $code = 422)
    {
        return $this
            ->statusCode($code)
            ->message($message ?: 'error')
            ->send();
    }

    /**
     * 设置字段验证错误信息，并响应
     *
     * @param $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationErrorResponse($errors)
    {
        if ($errors instanceof Validator) {
            // $errors = $errors->errors();
            $errors = $errors->getMessageBag()->first();
        }

        if ($errors instanceof MessageBag) {
            $errors = $errors->getMessages();
        }
        $error = is_array($errors) ? array_values($errors)[0] : $errors;
        return $this->statusCode(422)->message($error)->send();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function send()
    {
        $result = ['code' => $this->statusCode, 'message' => $this->message];

        if (!empty($this->data)) {
            // List with the page
            if (is_object($this->data) && $this->data instanceof AnonymousResourceCollection) {
                $meta = [
                    'total' => $this->data->total(),
                    'per_page' => $this->data->perPage(),
                    'current_page' => $this->data->currentPage()
                ];
                return response()->json($result + ['data' => ['list' => $this->data, 'meta' => $meta]], $this->statusCode);
            }
            return response()->json($result + ['data' => $this->data], $this->statusCode);
        }

        return response()->json($result, $this->statusCode);
    }

}
