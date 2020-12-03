<p align="center">
<a href="https://www.wpoets.com/" target="_blank"><img width="200"src="https://www.wpoets.com/wp-content/uploads/2018/05/WPoets-logo-1.svg"></a>
</p>

# Linkedin Handler for Awesome Enterprise
Add support of LinkedIn API in Awesome Enterprise, introduces linkedin shortcode

### Changelog  

##### 1.0.1
* Fixed: Switched the api library to a fork maintained at  https://github.com/samoritano/linkedin-api-php-client
  
##### 1.0.0  
* Initial release

### Issues 

While installing if you get issue like this 

` Problem 1
    - wpoets/linkedin-handler 1.0.0 requires zoonman/linkedin-api-php-client ^0.0.14 -> satisfiable by zoonman/linkedin-api-php-client[0.0.14].
    - Installation request for wpoets/linkedin-handler ^1.0 -> satisfiable by wpoets/linkedin-handler[1.0.0].
    - Conclusion: remove guzzlehttp/guzzle 7.2.0
    - Conclusion: don't install guzzlehttp/guzzle 7.2.0
    - zoonman/linkedin-api-php-client 0.0.14 requires guzzlehttp/guzzle ^6.3 -> satisfiable by guzzlehttp/guzzle[6.3.0, 6.3.1, 6.3.2, 6.3.3, 6.4.0, 6.4.1, 6.5.0, 6.5.1, 6.5.2, 6.5.3, 6.5.4, 6.5.5].
    - Can only install one of: guzzlehttp/guzzle[6.3.0, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.3.1, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.3.2, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.3.3, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.4.0, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.4.1, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.0, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.1, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.2, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.3, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.4, 7.2.0].
    - Can only install one of: guzzlehttp/guzzle[6.5.5, 7.2.0].
    - Installation request for guzzlehttp/guzzle (locked at 7.2.0) -> satisfiable by guzzlehttp/guzzle[7.2.0].`

Then here is what you can do to resolve it

1. Execute following to see which package requires it
`composer why guzzlehttp/guzzle`

2. Execute `composer require guzzlehttp/guzzle:^6.5`

3. Finally, again try to install LinkedIn Handler using
`composer require wpoets/linkedin-handler`

4. then remove the refernce of guzzle.



## We're Hiring!

<p align="center">
<a href="https://www.wpoets.com/careers/"><img src="https://www.wpoets.com/wp-content/uploads/2020/11/work-with-us_1776x312.png" alt="Join us at WPoets, We specialize in designing, building and maintaining complex enterprise websites and portals in WordPress."></a>
</p>