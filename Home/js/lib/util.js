// 验证标签显示
export function display(str) {

  if (str == "" || str == null || str == undefined || ( typeof str == "object" && str.length == 0 )) {
    return {display: 'none'};
  }
  return {}

};
// 把html字符串转换成html标签
export  function createMarkup(html) {
  return {__html: html};
};
// 二个参数有一个为空就不显示
export function displayTwo( str1, str2 ) {
  if ( str1 == "" || str2 == "" ) {
    return { display: 'none' };
  }
  return {}
}