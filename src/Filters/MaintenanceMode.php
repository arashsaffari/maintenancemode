<?php namespace CodeigniterExt\MaintenanceMode\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class MaintenanceMode implements FilterInterface
{
		/**
		 * This is a demo implementation of using the Throttler class
		 * to implement rate limiting for your application.
		 *
		 * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
		 *
		 * @return mixed
		 */
		public function before(RequestInterface $request)
		{
			\CodeigniterExt\MaintenanceMode\Controllers\MaintenanceMode::check();
		}

		//--------------------------------------------------------------------

		/**
		 * We don't have anything to do here.
		 *
		 * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
		 * @param ResponseInterface|\CodeIgniter\HTTP\Response       $response
		 *
		 * @return mixed
		 */
		public function after(RequestInterface $request, ResponseInterface $response)
		{
		}
}