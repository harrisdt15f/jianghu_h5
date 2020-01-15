<?php

namespace App\Http\Requests\Backend\Headquarters\Email;

use App\Http\Requests\BaseFormRequest;
use App\Models\Email\SystemEmail;
use App\Models\Email\SystemEmailReceiver;

/**
 * Class SendRequest
 *
 * @package App\Http\Requests\Backend\Headquarters\Email
 */
class SendRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
                'receivers'     => 'required|array',
                'receivers.*'   => 'required|distinct|email:rfc,dns|exists:merchant_admin_users,email',
                'title'         => 'required|string',
                'content'       => 'required|string',
                'is_timing'     => 'required|in:' . SystemEmail::IS_TIMING_NO . ',' . SystemEmail::IS_TIMING_YES,
                'send_time'     => 'required_if:is_timing,' . SystemEmail::IS_TIMING_YES . '|date|after:now',
                'receiver_type' => 'required|in:'  . SystemEmailReceiver::RECEIVER_TYPE_HEADQUARTERS .
                ',' . SystemEmailReceiver::RECEIVER_TYPE_MERCHANT . ',' . SystemEmailReceiver::RECEIVER_TYPE_PLAYER,
               ];
    }

    /**
     * @return mixed[]
     */
    public function messages(): array
    {
        return [
                'receivers.required'     => '请填写收件人',
                'receivers.array'        => '收件人格式错误',
                'receivers.*.required'   => '请填写收件人',
                'receivers.*.email'      => '收件人格式错误',
                'receivers.*.exists'     => ' 收件人不存在',
                'receivers.*.distinct'   => ' 收件人不能重覆',
                'title.required'         => '请填写邮件标题',
                'title.string'           => '邮件标题格式错误',
                'content.required'       => '请输入邮件内容',
                'content.string'         => '邮件内容格式错误',
                'is_timing.required'     => '请选择邮件发送方式',
                'is_timing.in'           => '所选邮件发送方式不在范围内',
                'send_time.required_if'  => '请填写延时发送时间',
                'send_time.date'         => '延时发送时间格式不正确',
                'send_time.after'        => '延时发送时间必须晚于当前时间',
                'receiver_type.required' => '请上传接收人类型',
                'receiver_type.in'       => '接收人类型不存在',
               ];
    }

    /**
     * @return mixed[]
     */
    public function filters(): array
    {
        return ['receivers' => 'cast:array'];
    }
}
