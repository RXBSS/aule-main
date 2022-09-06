<!-- Sweet Alert Template Löschen -->
<template id="my-template">
  <swal-title>
    Akquise Dauerhaft löschen oder Status auf gelöscht setzen?
  </swal-title>
  <swal-icon type="question" color="blue"></swal-icon>
  <swal-button type="confirm">
    Status auf gelöscht
  </swal-button>
  <swal-button type="cancel">
    Cancel
  </swal-button>
  <swal-button type="deny">
    Dauerhaft löchen
  </swal-button>
  <swal-param name="allowEscapeKey" value="false" />
  <swal-param
    name="customClass"
    value='{ "popup": "my-popup" }' />
</template>

<!-- Sweet Alert Template zum Status gelöscht setzen -->
<template id="test-template">
  <swal-title>
    Sie können den Status auf gelöscht setzen, wobei die Akquise in der Aktion erhalten bleibt oder Sie können die Akquise dauerhaft aus der Aktion löschen!
  </swal-title>
  <swal-icon type="question" color="blue"></swal-icon>
  <swal-button type="confirm">
    Status auf gelöscht
  </swal-button>
  <swal-button type="cancel">
    Abbrechen
  </swal-button>
  <swal-button type="deny">
    Akquise aus der Aktion entfernen
  </swal-button>
  <swal-param name="allowEscapeKey" value="false" />
  <swal-param
    name="customClass"
    value='{ "popup": "my-popup" }' />
</template>