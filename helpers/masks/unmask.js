export const unmask_numbers = (val) => {
  if (!val) {
    return null;
  }
  const PHONE_REGULAR = /[-()+ ]/gi;
  return val.replace(PHONE_REGULAR, '');
};
