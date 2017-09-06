<html>
<head>
<script>
function hypotenuse(m,n)
{
	function square(num)
	{
		return num*num;
	}
	return Math.sqrt(square(m)+square(n));
}
document.write(hypotenuse(4,3));
</script>
</head>
</html>
