try {
    window.MP_ID_TYPE = 0;
    const idl_sdk = '';
    var shouldBeAsync = false;
    var optimizeIDLCalls = true;
    var cookieKey = '_mplidl';

    if (idl_sdk && (!optimizeIDLCalls || !window._mp.getCookie(cookieKey))) {
      window._mp.addScript('mp-idl', idl_sdk, false);
    }
  } catch(e) {}