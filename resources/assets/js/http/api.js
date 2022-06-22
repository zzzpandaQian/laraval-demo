import {
    get,
    post,
    put,
    del
} from '../http/http';

//sms
export const VerifyCodeSms = params => post('sendsms', params);
export const VerifyCodeWechat = params => post('verify_code_wechat', params);

//Post
export const getNewsList = params => get('newslist', params);

export const getNewsDetail = params => get('news/' + params + '/detail');

//Contact
export const contactForm = params => post('contact', params);
